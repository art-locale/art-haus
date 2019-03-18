
import {Component, OnInit} from "@angular/core";
import {ImageService} from "../shared/services/image.service";
import {Router} from "@angular/router";
import {Image} from "../shared/interfaces/image";
//TODO the following were in George's working example for image
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {FileUploader} from "ng2-file-upload";

//TODO there is some code that seemed unnecessary for our use that George did have. See his example.

@Component({
	templateUrl: "./splash.component.html"
})

public uploader: FileUploader = new FileUploader(
	{
		itemAlias: 'image',
		url: './api/image/',
		headers: [
			//TODO I added JWT-TOKEN per George instructions
			{name: 'X-XSRF-TOKEN', value: this.cookieService.get('XSRF-TOKEN')},
			{name: 'X-JWT-TOKEN', value: this.cookieService.get('XSRF-TOKEN')}
		],
		additionalParameter: this.imageId
	}
);

export class SplashComponent implements OnInit{
	images: Image[] = [];

	constructor(protected imageService: ImageService, private router: Router) {}

	ngOnInit():void {
		this.imageService.getAllImages()
			.subscribe(images => this.images = images);
	}

	getDetailedView(image : Image) : void {
		this.router.navigate(["/detailed-user/", image.imageId]);
	}

}
