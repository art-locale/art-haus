import {Gallery} from "./gallery";
import {Profile} from "./profile"

export interface Image {
	imageid: number,
	imageGalleryId: number,
	imageProfileId: number,
	imageDate: string,
	imageTitle: string,
	imageUrl: string
}