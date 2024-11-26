// レコード要素の方定義
export type Artist = {
  authorId: number;
  userId: number;
  authorName: string;
  authorImage: string;
  //評価
  selfEvaluation: number;
  description: string;
  knowDate: string;
  memo: string;
}

export interface Constant {
  AUTHOR_LIST: { [key: number]: string };
}