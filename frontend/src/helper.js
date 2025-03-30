export function handleApiError(error) {
  if (error.response && error.response.data.errors) {
    return Object.values(error.response.data.errors).flat().join(" ");
  } else if (error.response && error.response.data.status === "error") {
    return error.response.data.message;
  } else {
    return "An error occurred. Please try again.";
  }
}