/*
 this component is for signing in to use the site.
 */

//import needed modules for the sign-in component
import {Component, Input, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {NgbActiveModal, NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';

import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../interfaces/status";
import {ProfileService} from "../services/profile.service";
import {SessionService} from "../services/session.service";
import {Profile} from "../interfaces/profile";

// set the template url and the selector for the ng powered html tag
@Component({
	templateUrl:"./update-profile.component.html",
	selector: "update-profile-form"
})

export class UpdateProfileComponent implements OnInit {

	updateProfileForm: FormGroup;

	status: Status = null;

	constructor(public activeModal: NgbActiveModal, private formBuilder: FormBuilder, private router: Router, private ProfileService: ProfileService, private sessionService: SessionService) {
	}

	ngOnInit(): void {
		this.updateProfileForm = this.formBuilder.group({
			id: ["", [Validators.maxLength(128), Validators.required]],
			profileAddress: ["", [Validators.maxLength(128), Validators.required]],
			profileDate: ["", [Validators.maxLength(128), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profileLatitude: ["", [Validators.maxLength(128), Validators.required]],
			profileLongitude: ["", [Validators.maxLength(128), Validators.required]],
			profileName: ["", [Validators.maxLength(128), Validators.required]],
			profilePassword: ["", [Validators.maxLength(128), Validators.required]],
			profileWebsite: ["", [Validators.maxLength(128), Validators.required]],
		});

		this.status = {status: null, message: null, type: null}

	}

	updateProfile(): void {
		let profile: Profile = {profileId: null, profileAddress: this.updateProfileForm.value.address, profileDate: null, profileEmail: this.updateProfileForm.value.email, profileLatitude: this.updateProfileForm.value.latitude, profileLongitude: this.updateProfileForm.value.longitude, profileName: this.updateProfileForm.value.name, profilePassword: this.updateProfileForm.value.password, profileWebsite: this.updateProfileForm.value.website};
		this.ProfileService.editProfile(profile)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert("Thanks for updating your profile!")
					this.updateProfileForm.reset();
					location.reload();

					this.router.navigate(["signed-in-homeview.php"])
				}
			});
	}
}



