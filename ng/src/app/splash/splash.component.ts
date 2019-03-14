
import {Component, OnInit} from "@angular/core";
//import {User} from "../shared/interfaces/profile";
import {ApiService} from "../shared/services/api.service";
import {Router} from "@angular/router";

@Component({
	templateUrl: "./splash.component.html"
})


export class SplashComponent implements OnInit{
	users: User[] = [];

	constructor(protected userService: ApiService, private router: Router) {}


	ngOnInit():void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}

	getDetailedView(user : User) : void {
		this.router.navigate(["/detailed-user/", user.userId]);
	}

}
