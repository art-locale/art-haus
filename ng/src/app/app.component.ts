import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";

@Component({
  selector: "data-design-app",
  templateUrl: ("./app.component.html")
})
export class AppComponent{



  status : Status = null;

  constructor(protected sessionService : SessionService) {
    this.sessionService.setSession()
       .subscribe(status => this.status = status);
  }
}


