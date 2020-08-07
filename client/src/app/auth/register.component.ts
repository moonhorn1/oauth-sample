import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ActivatedRoute, Router} from "@angular/router";
import {SecurityService} from "../security/security.service";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html'
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup;
  loading: boolean = false;
  submitted: boolean = false;

  returnUrl: string;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private route: ActivatedRoute,
    private securityService: SecurityService
  ) { }

  ngOnInit(): void {
    this.registerForm = this.formBuilder.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
      repeat:   ['', Validators.required],
    });

    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/app/home';
  }

  // convenience getter for easy access to form fields
  get f() { return this.registerForm.controls; }

  public register() {
    if (this.registerForm.invalid) {
      return;
    }

    this.securityService
      .register(this.f.username.value, this.f.password.value, this.f.repeat.value)
      .subscribe(success => {
        if (this.securityService.isAuthenticated()) {
          this.router.navigate([this.returnUrl]);
        }
      });
  }
}
