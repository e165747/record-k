export const constant = {
  index: '/api/records',
  store: '/api/records',
  update: (id: number) => `/api/records/${id}`,
  delete: (id: number) => `/api/records/${id}`,
  getDetail: (id: number) => `/api/records/${id}`,
}