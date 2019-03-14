import {Component, OnInit} from "@angular/core";
import {GalleryService} from "../shared/services/gallery.service";
import {Gallery} from "../shared/interfaces/gallery";
//TODO may or may not want profile here
import {Profile} from "../shared/interfaces/gallery"
import {FormGroup, FormBuilder, Validators} from "@angular/forms";
// import {repeat} from "rxjs/operators";
import {Status} from "../shared/interfaces/status";
// import {el} from "@angular/platform-browser/testing/src/browser_util";

@Component({
	templateUrl: "gallery.creation.component.html"
})

export class GalleryCreationComponent implements OnInit{
	//create state variable to house all data
	gallery : Gallery[] = [];
	creatGalleryForm : FormGroup;
	status: Status = new Status(null, null, null);
	constructor(private galleryService: GalleryService, private formBuilder : FormBuilder) {}

	//call onInit above to work (fulfill the contract)
	ngOnInit(): void {
		this.createGalleryForm = this.formBuilder.group({
			galleryName: ["", [Validators.maxLength(32), Validators.required]]
		});
		this.loadPosts();
	}

	loadPosts() {
		this.galleryService.getGalleryByGalleryName().subscribe(reply => this.gallery = reply);
	}

	createGallery(){
		let gallery: Gallery = {galleryId: null, galleryProfileId: null, galleryDate: null, galleryName: this.createGalleryForm.value.galleryName};
		this.galleryService.createGallery(gallery).subscribe(reply => {
			this.status = reply;
			if(this.status.status === 200) {
				alert("Yay post created");
				this.loadPosts();
			} else{
				alert("who taught how to type...");
			}
		})
	}

}