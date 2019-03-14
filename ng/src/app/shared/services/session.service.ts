import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Status} from "../interfaces/status";

@Injectable()
export class SessionService {

	constructor(protected http: HttpClient) {
	}

//define the API endpoint
	private sessionUrl = "/api/earl-grey/";

	setSession() {
		return (this.http.get<Status>(this.sessionUrl, {}));
	}

}


//TODO: Do we need this?
