import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import {ReactiveFormsModule} from "@angular/forms";
import {allAppComponents, providers, routing} from "./app.routes"
import { AppComponent } from './app.component';
import { SignInComponent} from "./sign-in.component";
import {ProfileViewComponent} from "./profile-view/profile.view.component";

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule],
  declarations: [ ...allAppComponents, AppComponent, SignInComponent, ProfileViewComponent],
  bootstrap:    [ AppComponent ],
  providers: [providers]
})
export class AppModule { }
