
import {Component, OnInit} from "@angular/core";
import {ImageService} from "../shared/services/image.service";
import {Router} from "@angular/router";
import {Image} from "../shared/interfaces/image";
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
	image: Image = {
		imageId: null,
		imageGalleryId: null,
		imageProfileId: null,
		imageDate: null,
		imageTitle: null,
		imageUrl: null
	};
	images: Image[] = [];
	imageNotSelected: boolean = true;

	public uploader: FileUploader = new FileUploader(
		{
			itemAlias: 'image',
			url: './api/image/',
			headers: [
				//TODO I added JWT-TOKEN per George instructions
				{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')},
				{name: 'X-JWT-TOKEN', value: this.cookieService.get('XSRF-TOKEN')}
			],
			additionalParameter: this.image
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
		this.imageService.getAllImages(this.imageId.imageId).subscribe(reply => this.images = reply);
	}
}
