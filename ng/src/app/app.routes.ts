import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import { SignInComponent} from "./shared/sign-in-component/sign-in.component";
// import { AddImageComponent} from "./shared/add-image-component/add-image.component";
// import { GalleryCreateComponent} from "./shared/gallery-create-component/gallery-create.component";

import {APP_BASE_HREF} from "@angular/common";

import {SessionService} from "./shared/services/session.service";
import {ProfileService} from "./shared/services/profile.service";
import {ImageService} from "./shared/services/image.service";
import {GalleryService} from "./shared/services/gallery.service";
import {ApplaudService} from "./shared/services/applaud.service";
import {SignInService} from "./shared/services/signIn.service";
import {SignUpService} from "./shared/services/signUp.service";
import {ProfileViewComponent} from "./profile-view/profile.view.component";
import {UpdateProfileComponent} from "./shared/update-profile-component/update-profile.component";
import {UpdateGalleryComponent} from "./shared/update-gallery-component/update-gallery.component";
import {GalleryCreateComponent} from "./shared/gallery-create-component/gallery-create.component";
import {AddImageComponent} from "./shared/add-image-component/add-image.component";
import {NgbActiveModal, } from "@ng-bootstrap/ng-bootstrap";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";
import {HTTP_INTERCEPTORS} from "@angular/common/http";

export const allAppComponents = [AppComponent, SplashComponent, SignUpComponent, SignInComponent, ProfileViewComponent, UpdateProfileComponent, UpdateGalleryComponent, GalleryCreateComponent, AddImageComponent];

export const routes: Routes = [
	{path: "profile/:profileId", component: ProfileViewComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "update-profile", component: UpdateProfileComponent},
	{path: "update-gallery", component: UpdateGalleryComponent},
	{path: "gallery-create", component: GalleryCreateComponent},
	{path: "add-image", component: AddImageComponent},
	{path: "", component: SplashComponent},
];

export const providers: any[] = [
SignUpService, SignInService, SessionService, ProfileService, ImageService, GalleryService, ApplaudService, NgbActiveModal,
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	];

export const routing = RouterModule.forRoot(routes);
