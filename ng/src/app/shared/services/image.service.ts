import {Injectable} from "@angular/core";
import {Image} from "../interfaces/image";
//TODO Not in George's example
import {Status} from "../interfaces/status";
//TODO added /internal/Observable to following
import {Observable} from "rxjs/internal/Observable";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable ()
export class ImageService {

constructor(protected http : HttpClient ) {}

//define the API endpoint
private imageUrl =  "/api/image/";

// call to the Image API and create the image in question
createImage(image : Image) : Observable<Status> {
return(this.http.post<Status>(this.imageUrl, image));
}
//TODO ONLY ONE OF THESE METHODS USED IN GEORGE EXAMPLE AND DIDN"T CORRESPOND TO THE GET IMAGE METHODS IN THE PHP CLASS
//call the image API and get by image id
getImageByImageId(imageId : string) : Observable <Image[]> {
return (this.http.get<Image[]>(this.imageUrl, {params: new HttpParams().set("imageId", imageId)}));
}

//call the image API and get by image gallery id
getImageByImageGalleryId(imageId : string, imageGalleryId : string) : Observable <Image[]> {
return (this.http.get<Image[]>(this.imageUrl, {params: new HttpParams().set("imageId", imageId).set("imageGalleryId", imageGalleryId)}));
}

//call the image API and get by image profile id
getImageByImageProfileId(imageId : string, imageProfileId : string) : Observable <Image[]> {
return (this.http.get<Image[]>(this.imageUrl, {params: new HttpParams().set("imageId", imageId).set("imageProfileId", imageProfileId)}));
}
//TODO THE REST WAS ALSO NOT IN GEORGE'S WORKING EXAMPLE
//reach out to the image API and delete the image in question
deleteImage(id : number) : Observable<Status> {
return(this.http.delete<Status>(this.imageUrl + id));
}

// call to the image API and edit the image in question
editImage(image: Image) : Observable<Status> {
return(this.http.put<Status>(this.imageUrl, image));
}

//call to the image API and get all images
	getAllImages() : Observable<Image[]> {
		return(this.http.get<Image[]>(this.imageUrl));
	}
}
