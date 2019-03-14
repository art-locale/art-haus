import {Injectable} from "@angular/core";

import {Gallery} from "../interfaces/gallery";
import {Status} from "../interfaces/status";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Profile} from "../interfaces/profile";

@Injectable ()
export class GalleryService {

constructor(protected http: HttpClient) {
}

//define the API endpoint
private galleryUrl =  "/api/gallery/";

// call to the Gallery API and create the gallery in question
createGallery(gallery: Gallery): Observable<Status> {
return (this.http.post<Status>(this.galleryUrl, gallery));
}

//call to API and delete a gallery
deleteGallery(gallery: Gallery): Observable<Status> {
return (this.http.delete<Status>(this.galleryUrl + gallery));
}

editGallery(gallery: Gallery): Observable<Status> {
return(this.http.put<Status>(this.galleryUrl, gallery));
}

//call the gallery API and get by gallery id
getGalleryByGalleryId(galleryId : string) : Observable <Gallery[]> {
return (this.http.get<Gallery[]>(this.galleryUrl, {params: new HttpParams().set("galleryId", galleryId)}));
}
//call the gallery API and get by gallery profile id
getGalleryByGalleryProfileId(galleryId : string, galleryProfileId : string) : Observable <Gallery[]> {
return (this.http.get<Gallery[]>(this.galleryUrl, {params: new HttpParams().set("galleryId", galleryId).set("galleryProfileId", galleryProfileId)}));
}
//call the gallery API and get by gallery name
getGalleryByGalleryName(galleryName : string) : Observable <Gallery[]> {
return (this.http.get<Gallery[]>(this.galleryUrl, {params: new HttpParams().set("galleryName", galleryName)}));
}

}
