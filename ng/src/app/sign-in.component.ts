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
			});

		//Sign In Modal//
		@Component({
			selector: 'ngbd-modal-content',
			template: `
				<!-- Sign In Modal -->
				<ng-template #content let-modal>
					<div class="modal fade" id="signInModalOne" tabindex="-1" role="dialog" aria-labelledby="signInModal" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="signInModalTwo">Please Sign In</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" (click)="modal.dismiss('Cross click')">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
									<form (submit)="createSignIn();" [formGroup]="signInForm" class="form-control-lg" id="signInForm" method="post" name="signInForm" novalidate>

										<div class="info">
											<!--Email-->
											<input class="form-control" formControlName="email" id="email" type="email" name="email" placeholder=" Email" />
											<div *ngIf="signInForm.controls.email?.invalid && signInForm.controls.email?.touched" class="alert alert-danger">
												<p *ngIf="signInForm.controls.email?.errors.required">The email is incorrect.</p>
											</div>

											<!--Password-->
											<input class="form-control" formControlName="password" id="password" type="text" name="password" placeholder=" Password" />
										</div>
										<div *ngIf="signInForm.controls.password?.invalid && signInForm.controls.password?.touched" class="alert alert-danger">
											<p *ngIf="signInForm.controls.password?.errors.required">The password is incorrect.</p>
										</div>

									</form>
									<!--TODO the working example from ABQ At Night has class of "control" in following div and then the value of "Submit". -->
									<div class="modal-footer">
										<input class="btn btn-info" (click)="modal.close('Sign in click') type="submit" value="Sign In" />
									</div>

								</div>
							</div>
						</div>
					</div>
  `
		})
}