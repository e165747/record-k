export const urls = {
  index: '/api/authors',
  store: '/api/authors',
  update: (id: number) => `/api/authors/${id}`,
  delete: (id: number) => `/api/authors/${id}`,
  getDetail: (id: number) => `/api/authors/${id}`,
  getAuthors: '/api/authors/get-authors',
  upsertImage: (id: number) => `/api/authors/${id}/upsert-image`,
}