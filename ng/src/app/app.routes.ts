import {RouterModule, Routes} from "@angular/router";
import {SplashComponent} from "./splash/splash.component";
import{AppComponent} from "./app.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import { SignInComponent} from "./sign-in.component";

import {APP_BASE_HREF} from "@angular/common";

import {SessionService} from "./shared/services/session.service";
import {ProfileService} from "./shared/services/profile.service";
import {ImageService} from "./shared/services/image.service";
import {GalleryService} from "./shared/services/gallery.service";
import {ApplaudService} from "./shared/services/applaud.service";
import {SignInService} from "./shared/services/signIn.service";
import {SignUpService} from "./shared/services/signUp.service";

export const allAppComponents = [AppComponent, SplashComponent, SignUpComponent];

export const routes: Routes = [
	{path: "sign-up", component: SignUpComponent},
	{path: "splash", component: SplashComponent},
	{path: "sign-in", component: SignInComponent}
];

export const providers: any[] = [
SignUpService, SignInService, SessionService, ProfileService, ImageService, GalleryService, ApplaudService
	];

export const routing = RouterModule.forRoot(routes);
