import { Injectable } from '@angular/core';
import { User } from "../model/user";
import {from, Observable, of} from "rxjs";
import { Router } from "@angular/router";
import { HttpClient, HttpErrorResponse } from "@angular/common/http";
import { throwError } from 'rxjs';
import { catchError, map, mergeMap} from 'rxjs/operators';
import { OAuthService } from "angular-oauth2-oidc";
import { passwordFlowConfig } from '../auth.config';
import { environment } from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class SecurityService {
  user: User;

  constructor(
    private router: Router,
    private httpClient: HttpClient,
    private oauthService: OAuthService,
  ) {
    this.oauthService.configure(passwordFlowConfig);
    this.oauthService.setupAutomaticSilentRefresh();
  }

  public isAuthenticated(): boolean {
    return this.oauthService.hasValidAccessToken();
  }

  login(username: string, password: string): Observable<boolean> {
    let authorize = this.oauthService.fetchTokenUsingPasswordFlow(username, password).then(() => {
      return true;
    });

    return from(authorize).pipe(catchError(this.handleError));
  }

  logout(): void {
    this.oauthService.revokeTokenAndLogout().then(() => {
        this.user = undefined;
        this.router.navigate(['/']);
      }
    );
  }

  register(username: string, password: string, repeat: string): Observable<boolean> {
    return this.httpClient.post(environment.authUrl + '/auth/signup', {'username': username, 'password': password})
      .pipe(
        catchError(this.handleError),
        mergeMap((data) => this.login(username, password))
      );
  }

  public getUser(): Observable<User> {
    if (undefined !== this.user ) {
      return of(this.user);
    }

    let profile = this.oauthService.loadUserProfile().then((token) => {
      let claims = this.oauthService.getIdentityClaims();

      if (claims) {
        // @ts-ignore
        return this.user = {username: claims.username, createdAt: claims.createdAt.date};
      }
    });

    return from(profile);
  }

  handleError(error: HttpErrorResponse) {
    let errorMessage = 'Unknown error!';
    if (error.error instanceof ErrorEvent) {
      errorMessage = `Error: ${error.error.message}`;
    } else {
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
    }
    window.alert(errorMessage);

    return throwError(errorMessage);
  }
}
