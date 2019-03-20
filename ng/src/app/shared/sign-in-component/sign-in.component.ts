/*
 this component is for signing in to use the site.
 */

//import needed modules for the sign-in component
import {Component, Input, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {NgbActiveModal, NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../interfaces/status";
import {SignInService} from "../services/signIn.service";
import {SessionService} from "../services/session.service";
import {SignIn} from "../interfaces/sign.in";


// set the template url and the selector for the ng powered html tag
@Component({
	templateUrl:"./sign.in.component.html",
	selector: "sign-in-form"
})

export class SignInComponent implements OnInit {

	signInForm: FormGroup;

	status: Status = null;

	constructor(public activeModal: NgbActiveModal, private formBuilder: FormBuilder, private router: Router, private signInService: SignInService, private sessionService: SessionService) {
	}

	ngOnInit(): void {
		this.signInForm = this.formBuilder.group({
			email: ["", [Validators.maxLength(128), Validators.required]],
			password: ["", [Validators.maxLength(97), Validators.required]]
		});

		this.status = {status: null, message: null, type: null}

	}

	createSignIn(): void {
	let	signIn: SignIn = {profileEmail: this.signInForm.value.email, profilePassword: this.signInForm.value.password};
		this.signInService.postSignIn(signIn)
			.subscribe(status => {
				this.status = status;

					this.router.navigate(["./profile-view"])

			});
	}
}



