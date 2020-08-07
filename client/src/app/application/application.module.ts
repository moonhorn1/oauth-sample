import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ApplicationRoutingModule } from './application-routing.module';
import { ApplicationComponent } from './application.component';
import { HomeComponent } from './home.component';
import { ProfileComponent } from './profile.component';


@NgModule({
  declarations: [ApplicationComponent, HomeComponent, ProfileComponent],
  imports: [
    CommonModule,
    ApplicationRoutingModule
  ]
})
export class ApplicationModule { }
