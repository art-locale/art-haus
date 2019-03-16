/*
 this component is for signing in to use the site.
 */

//import needed modules for the sign-in component
import {Component, Input, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {NgbActiveModal, NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';

import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../interfaces/status";
import {GalleryService} from "../services/gallery.service";
import {SessionService} from "../services/session.service";
import {Gallery} from "../interfaces/gallery";

// set the template url and the selector for the ng powered html tag
@Component({
	templateUrl:"./gallery-create.component.html",
	selector: "gallery-create-form"
})

export class GalleryCreateComponent implements OnInit {

	galleryCreateForm: FormGroup;


	status: Status = null;

	constructor(public activeModal: NgbActiveModal, private formBuilder: FormBuilder, private router: Router, private GalleryService: GalleryService, private sessionService: SessionService) {
	}

	ngOnInit(): void {
		this.addGalleryForm = this.formBuilder.group({
			name: ["", [Validators.maxLength(128), Validators.required]]
		});

		this.status = {status: null, message: null, type: null}

	}

	createSignIn(): void {
		let gallery: Gallery = {galleryName: this.galleryCreateForm.value.name};
		this.galleryService.postGalleryCreate(Gallery)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert("Thanks for creating a gallery!")
					this.galleryCreateForm.reset();
					location.reload();

					this.router.navigate(["signed-in-homeview.php"])
				}
			});
	}
}



