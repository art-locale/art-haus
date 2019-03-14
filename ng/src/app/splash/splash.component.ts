
import {Component, OnInit} from "@angular/core";
import {ImageService} from "../shared/services/image.service";
import {Router} from "@angular/router";
import {Image} from "/shared/interfaces/image";

@Component({
	templateUrl: "./splash.component.html"
})


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
