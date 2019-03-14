
import {Component, OnInit} from "@angular/core";
//import {User} from "../shared/interfaces/profile";
import {ApiService} from "../shared/services/api.service";
import {Router} from "@angular/router";

@Component({
	templateUrl: "./splash.component.html"
})


export class SplashComponent implements OnInit{
	images: Image[] = [];

	constructor(protected userService: ApiService, private router: Router) {}


	ngOnInit():void {
		this.userService.getAllImages()
			.subscribe(images => this.images = images);
	}

	getDetailedView(image : Image) : void {
		this.router.navigate(["/detailed-user/", image.imageId]);
	}

}
