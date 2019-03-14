import {Component, OnInit} from "@angular/core";
import {GalleryService} from "../shared/services/gallery.service";
import {Gallery} from "../shared/interfaces/gallery";
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
// import {repeat} from "rxjs/operators";
import {Status} from "../shared/interfaces/status";
// import {el} from "@angular/platform-browser/testing/src/browser_util";

@Component({
	templateUrl: "gallery.view.component.html"
})

export class GalleryViewComponent implements OnInit{
	//create state variable to house all data
	gallery : Gallery[] = [];
	status: Status = new Status(null, null, null);
	constructor(private galleryService: GalleryService) {}

	//call onInit above to work (fulfill the contract)
	ngOnInit(): void {
		this.loadGallery();
	}

	loadGallery() {
		this.galleryService.getGalleryByGalleryName().subscribe(reply => this.gallery = reply);
	}
}