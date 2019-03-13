import {Profile} from "./profile.ts";
import {Image} from "./image.ts"

export interface Applaud {
	applaudProfileId: number,
	applaudImageId: number,
	applaudCount: number
}