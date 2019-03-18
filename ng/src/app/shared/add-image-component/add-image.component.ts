import {Component, Input, OnInit} from '@angular/core';
import {NgbActiveModal, NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {FileUploader} from "ng2-file-upload";
import { CookieService } from 'ngx-cookie';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

@Component({

		templateUrl: "./add-image.component.html"
	}
)

export class AddImageComponent implements OnInit{

	imageCreateForm: FormGroup;

	uploader: FileUploader = null;
	constructor(private activeModalService: NgbActiveModal,private cookieService: CookieService, private formBuilder: FormBuilder){}



	ngOnInit(): void {
		this.imageCreateForm = this.formBuilder.group({imageTitle: ["",[ Validators.maxLength(32), Validators.required]]});
		this.uploader = new FileUploader(
			{
				itemAlias: 'image',
				url: './api/image/',
				additionalParameter: {}
			}
		);
	}

	closeModalButton(){
		this.activeModalService.dismiss("Cross click")
	}

	submitImage(){
		this.uploader.options.additionalParameter = {imageTitle: ""}
	}
}