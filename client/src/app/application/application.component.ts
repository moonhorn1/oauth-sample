import { Component, OnInit } from '@angular/core';
import {SecurityService} from "../security/security.service";

@Component({
  selector: 'app-application',
  templateUrl: './application.component.html'
})
export class ApplicationComponent implements OnInit {

  constructor(private securityService: SecurityService) { }

  ngOnInit(): void {
  }

  logout() {
    this.securityService.logout();
  }
}
