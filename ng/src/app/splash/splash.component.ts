
import {Component, OnInit} from "@angular/core";
import {ImageService} from "../shared/services/image.service";
import {Router} from "@angular/router";
import {Image} from "../shared/interfaces/image";
import {Profile} from "../shared/interfaces/profile";
import {Gallery} from "../shared/interfaces/gallery";
//TODO the following were in George's working example for image
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {FileUploader} from "ng2-file-upload";
import {CookieService} from "ngx-cookie";
//following from Georges was unused as well, but it was CreateTweetComponent
// import {AddImageComponent} from "../shared/add-image-component/add-image.component"

//TODO there is some code that seemed unnecessary for our use that George did have. See his example.

@Component({
	templateUrl: "./splash.component.html"
})

export class SplashComponent implements OnInit {
	//TODO seriously not sure about the following three lines.
	profileId = {profileId: "25062bc2-6054-401b-9f02-97e841663da9"};
	profile: Profile = {profileId: null, profileDate: null, profileEmail: null, profileLatitude: null, profileLongitude: null, profileName: null, profilePassword: null, profileWebsite: null};
	galleryId = {galleryId: "12f2ed5f-9341-4450-9174-24eaadd6e3e2"};
	gallery: Gallery = {galleryId: null, galleryProfileId: null, galleryDate: null, galleryName: null};
	images: Image[] = [];
	imageNotSelected: boolean = true;

	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'image',
			url: './api/image/',
			headers: [
				//TODO I added JWT-TOKEN per George instructions
				{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')},
				{name: 'X-JWT-TOKEN', value: this.cookieService.get('JWT-TOKEN')}
			],
			// additionalParameter: this.imageId
		}
	);

	constructor(protected imageService: ImageService, private router: Router, private modalService: NgbModal, private cookieService: CookieService) {
	}

	ngOnInit(): void {
		//TODO did not have imageservice in his example just this.getImageBy... Also wasn't sure if we could use getAllImages here
		this.getAllImages();
		//TODO may want to delete console.log later
		console.log(this.uploader);
	}

//TODO this also was not in his...
// 	getDetailedView(image : Image) : void {
// 		this.router.navigate(["/detailed-user/", image.imageId]);
// 	}

	uploadImage(): void {
this.uploader.uploadAll();
	}

	getAllImages() {
		this.imageService.getAllImages().subscribe(reply => this.images = reply);
	}
}
