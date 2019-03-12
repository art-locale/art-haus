import {Injectable} from "@angular/core";


import {Gallery} from "../interfaces/gallery";
//import {Applaud} from "../interfaces/applaud";
//import {SignUp} from "../interfaces/sign.up";
//import {SignIn} from "../interfaces/sign.in";
//import {SignOut} from "../interfaces/sign.out";
import {Status} from "../interfaces/status";
//import {EarlGrey} from "../interfaces/earlGrey";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class ApiService {

	constructor(protected http : HttpClient ) {}