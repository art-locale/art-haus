import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {allAppComponents, providers, routing} from "./app.routes";
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppComponent } from './app.component';
import {SignInComponent} from "./sign-in.component";

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, NgbModule],
  declarations: [ ...allAppComponents, AppComponent ],
  entryComponents: [SignInComponent],
  bootstrap:    [ AppComponent ],
  providers: [providers]
})
export class AppModule { }
