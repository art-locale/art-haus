import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";

@Component({
  selector: "app-root",
  templateUrl: ("./app.component.html")
})
export class AppComponent{



  status : Status = null;

  constructor(protected sessionService : SessionService) {
    this.sessionService.setSession()
       .subscribe(status => this.status = status);
  }
}


