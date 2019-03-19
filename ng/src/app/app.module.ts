import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {allAppComponents, providers, routing} from "./app.routes";
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppComponent } from './app.component';
import {SignInComponent} from "./shared/sign-in-component/sign-in.component";
import {AddImageComponent} from "./shared/add-image-component/add-image.component";
import {CookieModule} from "ngx-cookie";
import { FileUploadModule } from "ng2-file-upload";
import {UpdateProfileComponent} from "./shared/update-profile-component/update-profile.component";
import {JwtModule} from "@auth0/angular-jwt";

//configure the parameters fot the JwtModule
const JwtHelper = JwtModule.forRoot({
  config: {
    tokenGetter: () => {
      return localStorage.getItem("jwt-token");
    },
    skipWhenExpired:true,
    whitelistedDomains: ["localhost:4200", "https://bootcamp-coders.cnm.edu/"],
    headerName:"X-JWT-TOKEN",
    authScheme: ""
  },
});

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, NgbModule, CookieModule.forRoot(), FileUploadModule, JwtHelper],
  declarations: [ ...allAppComponents, AppComponent ],
  entryComponents: [SignInComponent, UpdateProfileComponent, AddImageComponent],
  bootstrap:    [ AppComponent ],
  providers: [providers]
})
export class AppModule { }
