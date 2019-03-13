import {Gallery} from "./gallery";
import {Profile} from "./profile"

export interface Image {
	imageid: number,
	imageGalleryId: ?,
	imageProfileId: ?,
	imageDate: string,
	imageTitle: string,
	imageUrl: string
}