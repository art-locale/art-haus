/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, OnInit, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";

import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUp} from "../shared/interfaces/sign.up";
import {Status} from "../shared/interfaces/status";
import {SignUpService} from "../shared/services/signUp.service";


// set the template url and the selector for the ng powered html tag
@Component({
    templateUrl:"./sign-up.component.html",
})

export class SignUpComponent implements OnInit{

    signUpForm : FormGroup;
    status : Status = {status : null, message: null, type: null};

	constructor(private formBuilder : FormBuilder, private router: Router, private signUpService: SignUpService) {}

	ngOnInit()  : void {
		this.signUpForm = this.formBuilder.group({
			name: ["", [Validators.maxLength(32), Validators.required]],
			email: ["", [Validators.maxLength(128), Validators.required]],
			addressLine1: ["", [Validators.maxLength(32), Validators.required]],
			addressLine2: ["", [Validators.maxLength(32), Validators.required]],
			city: ["", [Validators.maxLength(32), Validators.required]],
			state: ["", [Validators.maxLength(32), Validators.required]],
			zipCode: ["", [Validators.maxLength(32), Validators.required]],
			country: ["", [Validators.maxLength(32), Validators.required]],
			website: ["", [Validators.maxLength(128), Validators.required]],
			password:["", [Validators.maxLength(97), Validators.required]],
			passwordConfirm:["", [Validators.maxLength(97), Validators.required]]

		});

		this.status = {status : null, message: null, type: null}

	}

	createSignUp(): void {

		let signUp : SignUp = {
			profileId: this.signUpForm.value.null,
			profileDate: this.signUpForm.value.date,
			profileName: this.signUpForm.value.name,
			profileEmail: this.signUpForm.value.email,
			profileAddressLine1: this.signUpForm.value.addressLine1,
			profileAddressLine2: this.signUpForm.value.addressLine2,
			profileCity: this.signUpForm.value.city,
			profileState: this.signUpForm.value.state,
			profileZip: this.signUpForm.value.zip,
			profileCountry: this.signUpForm.value.country,
			profileWebsite: this.signUpForm.value.website,
			profilePassword: this.signUpForm.value.password,
			profilePasswordConfirm: this.signUpForm.value.passwordConfirm
      };

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					//this.router.navigate([""]);
				}
			});
	}
}
