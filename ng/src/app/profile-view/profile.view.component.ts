import {Component, OnInit} from "@angular/core";
// import {Router} from "@angular/router";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";
// import {FormGroup, FormBuilder, Validators} from "@angular/forms";
// import {repeat} from "rxjs/operators";

// import {AuthService} from "../shared/services/auth.service";
// import {el} from "@angular/platform-browser/testing/src/browser_util";
// import {SessionService} from "../shared/services/session.service";

@Component({
	templateUrl: "./profile.view.component.html"
})

export class ProfileViewComponent implements OnInit{
	//create state variable to house all data
	profile : Profile = {
		profileId: null,
		// profileAddress: null,
		profileDate: null,
		profileEmail: null,
		profileLatitude: null,
		profileLongitude: null,
		profileName: null,
		profilePassword: null,
		profileWebsite: null
	};

	// status: Status = (status : null, message: null, type: null);

	constructor(private profileService: ProfileService, private activatedRoute : ActivatedRoute) {}

	//call onInit above to work (fulfill the contract)
	ngOnInit(): void {
		this.getDetailedProfile(this.activatedRoute.snapshot.params["profileId"]);
	}

	// loadProfile() {
	// 	this.profileService.getProfileByProfileId().subscribe(reply => this.profile = reply);
	// }

	getDetailedProfile(profileId : string) : void {
		this.profileService.getProfileByProfileId(profileId).subscribe(reply => {
			reply= this.profile;
		})
	}
}