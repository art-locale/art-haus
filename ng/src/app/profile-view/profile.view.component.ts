import {Component, OnInit} from "@angular/core";
// import {Router} from "@angular/router";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
// import {FormGroup, FormBuilder, Validators} from "@angular/forms";
// import {repeat} from "rxjs/operators";
import {Status} from "../shared/interfaces/status";
// import {AuthService} from "../shared/services/auth.service";
// import {el} from "@angular/platform-browser/testing/src/browser_util";
// import {SessionService} from "../shared/services/session.service";

@Component({
	templateUrl: "./profile.view.component.html",
	selector: 'profile-view-component'
})

export class ProfileViewComponent implements OnInit{
	//create state variable to house all data
	profile : Profile [] = [];
	status: Status = (status : null, message: null, type: null};

	constructor(private profileService: ProfileService) {}

	//call onInit above to work (fulfill the contract)
	ngOnInit(): void {
		this.loadProfile();
	}

	loadProfile() {
		this.profileService.getProfileByProfileId().subscribe(reply => this.profile = reply);
	}
}