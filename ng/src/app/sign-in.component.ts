/*
 this component is for signing in to use the site.
 */

//import needed modules for the sign-in component
import {Component, OnInit, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {NgbModal, ModalDismissReasons} from '@ng-bootstrap/ng-bootstrap';

import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignIn} from "./shared/interfaces/sign.in";
import {Status} from "./shared/interfaces/status";
import {SignInService} from "./shared/services/signIn.service";
import {SessionService} from "./shared/services/session.service";

// set the template url and the selector for the ng powered html tag
@Component({
	templateUrl:"./sign.in.component.html",
	selector: "sign-in-form"
})

export class SignInComponent implements OnInit {

	signInForm: FormGroup;

	signIn: SignIn = {profileEmail:null, profilePassword:null};
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private router: Router, private signInService: SignInService, private sessionService: SessionService) {
	}

	ngOnInit(): void {
		this.signInForm = this.formBuilder.group({
			email: ["", [Validators.maxLength(128), Validators.required]],
			password: ["", [Validators.maxLength(97), Validators.required]]
		});

		this.status = {status: null, message: null, type: null}

	}

	createSignIn(): void {

		this.signInService.postSignIn(this.signIn)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					this.sessionService.setSession();
					this.signInForm.reset();
					location.reload();

					this.router.navigate(["signed-in-homeview.php"])
				}
			})

	}
}



