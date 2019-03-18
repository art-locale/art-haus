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

export const allAppComponents = [AppComponent, SplashComponent, SignUpComponent, SignInComponent, ProfileViewComponent, UpdateProfileComponent, UpdateGalleryComponent]; //Add GalleryCreateComponent

export const routes: Routes = [
	{path: "profile/:profileId", component: ProfileViewComponent},
	{path: "sign-up", component: SignUpComponent},
	{path: "update-profile", component: UpdateProfileComponent},
	{path: "update-gallery", component: UpdateGalleryComponent},
	{path: "", component: SplashComponent},
];

export const providers: any[] = [
SignUpService, SignInService, SessionService, ProfileService, ImageService, GalleryService, ApplaudService
	];

export const routing = RouterModule.forRoot(routes);
