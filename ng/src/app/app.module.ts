import { NgModule,  } from '@angular/core';
import {HttpClientModule} from "@angular/common/http";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {allAppComponents, providers, routing} from "./app.routes";
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppComponent } from './app.component';
import {SignInComponent} from "./shared/sign-in-component/sign-in.component";
import {AddImageComponent} from "./shared/add-image-component/add-image.component";
import {GalleryCreateComponent} from "./shared/gallery-create-component/gallery-create.component";

@NgModule({
  imports:      [ BrowserModule, FormsModule, HttpClientModule, routing, ReactiveFormsModule, NgbModule],
  declarations: [ ...allAppComponents, AppComponent ], //Add SignInComponent back...
  entryComponents: [SignInComponent, AddImageComponent, GalleryCreateComponent],
  bootstrap:    [ AppComponent ],
  providers: [providers]
})
export class AppModule { }
