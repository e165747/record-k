// レコード要素の方定義
export type Record = {
  id: number;
  name: string;
  imagePath: string;
  //評価
  evaluation: number;
  description: string;
  isPossession: boolean;
  memo: string;
}