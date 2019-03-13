import {Injectable} from "@angular/core";

import {Profile} from "../interfaces/profile";
import {Status} from "../interfaces/status";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable ()
export class ProfileService {

constructor(protected http : HttpClient ) {}

//define the API endpoint
private profileUrl = "https://bootcamp-coders.cnm.edu/~bhuffman1/art-haus/public_html/api/profile/";

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

// call to the Profile API and get a Profile object by its id
getProfileByProfileId(id: number) : Observable<Profile> {
return(this.http.get<Profile>(this.profileUrl + id));
}

// call to the API to grab an array of profiles based on the user input
getProfileByName(profileUserName: string) :Observable<Profile[]> {
return(this.http.get<Profile[]>(this.profileUrl, {params: new HttpParams().set("profileUserName", profileUserName)}));
}
//reach out to the profile API and delete the profile in question
deleteProfile(id : number) : Observable<Status> {
return(this.http.delete<Status>(this.profileUrl + id));
}

// call to the Profile API and edit the profile in question
editProfile(profile: Profile) : Observable<Status> {
return(this.http.put<Status>(this.profileUrl, profile));
}

//call to the profile API and get all profiles
	getAllProfiles() : Observable<Profiles[]> {
		return(this.http.get<Profiles[]>(this.profileUrl));
	}
}
