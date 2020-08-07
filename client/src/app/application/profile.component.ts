import { Component, OnInit } from '@angular/core';
import {User} from "../model/user";
import {SecurityService} from "../security/security.service";

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html'
})
export class ProfileComponent implements OnInit {

  user: User;

  constructor(private securityService: SecurityService) { }

  ngOnInit(): void {
    this.securityService.getUser().subscribe(user => this.user = user);
  }
}
