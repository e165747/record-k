// レコード要素の方定義
export type Record = {
  id: number;
  authorId: number;
  name: string;
  imagePath: string;
  //評価
  evaluation: number;
  description: string;
  isPossession: boolean;
  memo: string;
  purchaseDate: string;
}

export interface Constant {
  AUTHOR_LIST: { [key: number]: string };
}