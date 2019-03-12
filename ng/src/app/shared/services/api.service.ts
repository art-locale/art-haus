import {Injectable} from "@angular/core";

//import {Profile} from "../interfaces/profile";
import {Image} from "../interfaces/image";
import {Gallery} from "../interfaces/gallery";
import {Applaud} from "../interfaces/applaud";
import {SignUp} from "../interfaces/sign.up";
import {SignIn} from "../interfaces/sign.in";
import {SignOut} from "../interfaces/sign.out";
import {Status} from "../interfaces/status";
//import {EarlGrey} from "../interfaces/earlGrey";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}

	//TODO: what is required for EarlGrey service?

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
	// call to the Profile API and get a Profile object by its id
	getProfileByProfileId(id: number) : Observable<Profile> {
		return(this.http.get<Profile>(this.apiUrl + id));
	}

	// call to the API to grab an array of profiles based on the user input
	getProfileByName(profileUserName: string) :Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.apiUrl, {params: new HttpParams().set("profileUserName", profileUserName)}));
	}

	//call to the profile API and grab the corresponding profile by its email
	getProfileByProfileEmail(profileEmail: string) :Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.apiUrl, {params: new HttpParams().set("profileEmail", profileEmail)}));
	}

	//call the image API and get by image id
	getImageByImageId(imageId : string) : Observable <Image[]> {
		return (this.http.get<Image[]>(this.apiUrl, {params: new HttpParams().set("imageId", imageId)}));
	}
	//call the image API and get by image gallery id
	getImageByImageGalleryId(imageId : string, imageGalleryId : string) : Observable <Image[]> {
		return (this.http.get<Image[]>(this.apiUrl, {params: new HttpParams().set("imageId", imageId).set("imageGalleryId", imageGalleryId)}));
	}
	//call the image API and get by image profile id
	getImageByImageProfileId(imageId : string, imageProfileId : string) : Observable <Image[]> {
		return (this.http.get<Image[]>(this.apiUrl, {params: new HttpParams().set("imageId", imageId).set("imageProfileId", imageProfileId)}));
	}

// call to the Profile API and get a Profile object by its id
	getProfileByProfileId(id: number) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + id));
	}

// call to the API to grab an array of profiles based on the user input
	getProfileByName(profileUserName: string) :Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.profileUrl, {params: new HttpParams().set("profileUserName", profileUserName)}));
	}

//call to the profile API and grab the corresponding profile by its email
	getProfileByProfileEmail(profileEmail: string) :Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.profileUrl, {params: new HttpParams().set("profileEmail", profileEmail)}));
	}
}

// call to the Applaud API and get a Applaud object by its foreign key, profile id
getApplaudByApplaudProfileId(applaudProfileId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudProfileId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageId(applaudImageId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudImageId));
}

// call to the Applaud API and get an Applaud object by its foreign key, image id
getApplaudByApplaudImageIdandApplaudProfileId(applaudProfileId: string, applaudImageId: string) : Observable<Applaud[]> {
	return(this.http.get<Applaud[]>(this.apiUrl + applaudProfileId + applaudImageId));
}
// }



	//*********************API CALLS -- DELETE METHODS:**************************
	//call to API and delete a gallery
	deleteGallery(gallery : Gallery) : Observable<Status> {
		return(this.http.delete<Status>(this.apiUrl + galleryId));
	}

	//reach out to the profile API and delete the profile in question
	deleteProfile(id : number) : Observable<Status> {
		return(this.http.delete<Status>(this.apiUrl + id));
	}

	//reach out to the image API and delete the image in question
	deleteImage(id : number) : Observable<Status> {
		return(this.http.delete<Status>(this.apiUrl + id));
	}

	//reach out to the applaud API and delete the applaud in question
	deleteApplaud(id : number) : Observable<Status> {
		return(this.http.delete<Status>(this.apiUrl + id));
	}



	//*********************API CALLS -- PUT METHODS:**************************
	editGallery(gallery : Gallery) : Observable<Status> {
		return(this.http.put<Status>(this.apiUrl + galleryId));
}

// call to the Profile API and edit the profile in question
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.apiUrl, profile));
	}

// call to the image API and edit the image in question
	editImage(image: Image) : Observable<Status> {
		return(this.http.put<Status>(this.apiUrl, image));
	}

	// call to the Profile API and edit the profile in question
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.profileUrl, profile));
	}



}//END OF api.services.ts




