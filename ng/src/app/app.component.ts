import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/signIn.service";
//TODO May need to be more like the contact form George demo'd

@Component({
  selector: "app-root",
  templateUrl: "./app.component.html"
})
export class AppComponent{



  status : Status = null;

  constructor(protected sessionService : SessionService) {
    this.sessionService.setSession()
       .subscribe(status => this.status = status);
  }
}


