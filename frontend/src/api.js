import axios from "axios";

const api = axios.create({
  baseURL: "https://sariph-pos-main-74qo8b.free.laravel.cloud/api",
  headers: { "Content-Type": "application/json" },
});

api.interceptors.request.use(function(config) {
  var token = localStorage.getItem("token");
  if (token) config.headers.Authorization = "Bearer " + token;
  return config;
});

export default api;
