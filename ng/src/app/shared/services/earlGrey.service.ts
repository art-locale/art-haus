import {Injectable} from "@angular/core";

import {Applaud} from "../interfaces/earlGrey";
import {Status} from "../interfaces/status";

import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable ()
export class EarlGreyService {

constructor(protected http : HttpClient ) {}

//define the API endpoint
private earlGreyUrl = "https://bootcamp-coders.cnm.edu/~gkephart/ng-demo7-backend/public_html/api/";

//TODO: What needs to be here?
