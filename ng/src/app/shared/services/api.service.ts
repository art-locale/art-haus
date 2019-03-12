import {Injectable} from "@angular/core";

//import {Profile} from "../interfaces/profile";
import {Image} from "../interfaces/image";
import {Gallery} from "../interfaces/gallery";
import {Applaud} from "../interfaces/applaud";
import {SignUp} from "../interfaces/sign.up";
import {SignIn} from "../interfaces/sign.in";
import {SignOut} from "../interfaces/sign.out";
import {Status} from "../interfaces/status";
import {EarlGrey} from "../interfaces/earlGrey";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}

	//define the API endpoint
	//TODO: what url do we use? Maybe Brandon's since he has XXAMP
	private apiUrl = "https://bootcamp-coders.cnm.edu/~gkephart/ng-demo7-backend/public_html/api/";

//*********************API CALLS -- POST METHODS:**************************
	// call to the Profile API and create the profile in question
	// TODO: is this the same as sign-up? Possibly delete this method.
	// createProfile(profile : Profile) : Observable<Status> {
	// 	return(this.http.post<Status>(this.apiUrl, profile));
	// }

	// call to the Image API and create the image in question
	createImage(image : Image) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, image));
	}

	// call to the Gallery API and create the gallery in question
	createGallery(gallery : Gallery) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, gallery));
	}

	// call to the Applaud API and create the applaud in question
	createApplaud(applaud : Applaud) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, applaud));
	}

	// call to the Sign-in API and create the sign-in in question
	postSignIn(signIn : SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signIn));
	}

	// call to the Sign-up API and create the sign-up in question
	//TODO: is this correct for create profile/ sign up?
	createProfile(signUp : SignUp) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signUp));
	}

	// call to the Sign-out API and create the sign-out in question
	postSignOut(signOut : SignOut) : Observable<Status> {
		return(this.http.post<Status>(this.apiUrl, signOut));
	}



	//***************API CALLS -- GET METHODS*********************************
	// call to the tweet API and get a tweet object based on its Id
	getUser(userId : string) : Observable<User> {
		return(this.http.get<User>(this.apiUrl + userId));
	}

	// call to the API and get an array of tweets based off the profileId
	getDetailedUser(userId : string) : Observable<UserPosts[]> {
		return(this.http.get<UserPosts[]>(this.apiUrl + "?postUserId=" + userId ));
	}

	//call to the API and get an array of all the tweets in the database
	getAllUsers() : Observable<User> {
		return(this.http.get<User>(this.apiUrl));
	}

}


sign-in service
—
sign-up service
—
sign-out service
—
earl-grey service
—
applaud serivce
—
image service
—
profile service
—
gallery service
