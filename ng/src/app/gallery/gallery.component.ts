import {Component} from "@angular/core";
import {GalleryService} from "../shared/services/gallery.service";
import {Gallery} from "../shared/";
import { } from "";

@Component({
	templateUrl: "gallery.component.html"
})

export class GalleryComponent implements OnInit{
	//create statevariable to house all data
	gallery : Gallery[] = [];
	constructor(private galleryService: GalleryService) {}

	//must call for OnInit above to work (fulfill the contract)
	ngOnInit() : void {}
		this.loadGallery();
	loadGallery() {
		this.postService.getGalleryByProfileId()
			.subscribe(
				reply => this.gallery = reply
			)
	}
}