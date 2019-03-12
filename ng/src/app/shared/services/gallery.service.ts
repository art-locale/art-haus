import {Injectable} from "@angular/core";


import {Gallery} from "../interfaces/gallery";
import {Status} from "../interfaces/status";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http: HttpClient) {
	}

//define the API endpoint
	//TODO: what url do we use? Maybe Brandon's since he has XXAMP
	private galleryUrl = //"https://bootcamp-coders.cnm.edu/~gkephart/ng-demo7-backend/public_html/api/";

	// call to the Gallery API and create the gallery in question
	createGallery(gallery: Gallery): Observable<Status> {
		return (this.http.post<Status>(this.galleryUrl, gallery));
	}

	//call to API and delete a gallery
	deleteGallery(gallery: Gallery): Observable<Status> {
		return (this.http.delete<Status>(this.galleryUrl + galleryId));
	}

	//*********************API CALLS -- PUT METHODS:**************************
	editGallery(gallery: Gallery): Observable<Status> {
		return (this.http.put<Status>(this.galleryUrl + galleryId));
	}

}