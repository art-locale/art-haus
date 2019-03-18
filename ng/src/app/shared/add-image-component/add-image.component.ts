/*
 this component is for signing in to use the site.
 */

//import needed modules for the sign-in component
//TODO Removed ViewChild and Input from the following import
import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {NgbActiveModal, NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';

import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../interfaces/status";
import {ImageService} from "../services/image.service";
import {SessionService} from "../services/session.service";
import {Image} from "../interfaces/image";


// set the template url and the selector for the ng powered html tag
@Component({
	templateUrl:"./add-image.component.html",
	selector: "add-image-form"
})

export class AddImageComponent implements OnInit {

	addImageForm: FormGroup;


	status: Status = null;

	constructor(public activeModal: NgbActiveModal, private formBuilder: FormBuilder, private router: Router, private ImageService: ImageService, private sessionService: SessionService) {
	}

	ngOnInit(): void {
		this.addImageForm = this.formBuilder.group({
			title: ["", [Validators.maxLength(128), Validators.required]]
		});

		this.status = {status: null, message: null, type: null}

	}

	editImage(): void {
		let	image: Image = {imageTitle: this.addImageForm.value.title};
		this.ImageService.editImage(Image)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert("Thanks for adding an image!")
					this.addImageForm.reset();
					location.reload();

					this.router.navigate(["signed-in-homeview.php"])
				}
			});
	}
}



