/** Delete Data */
const btnDeleteData = document.querySelectorAll('[data-action="deleteData"]');
const btnDeleteDataModal = document.querySelector('#btnDeleteDataModal');
btnDeleteData.forEach((e) => {
  e.addEventListener('click', () => {
    btnDeleteDataModal.href = `/api/deleteApi.php?id=${e.dataset.id}`;
  });
});

/** Get User Data for Edit */
function getUserData(id) {
  return fetch(`/api/getUserData.php?id=${id}`).then((res) => res.json());
}

/** Edit Data */
const btnEditData = document.querySelectorAll('[data-action="editData"]');
btnEditData.forEach((e) => {
  e.addEventListener('click', async () => {
    const userData = await getUserData(e.dataset.id);
    console.log(userData);
    document.querySelector('#idHiddenModal').value = userData.id;
    document.querySelector('#nameInputModal').value = userData.name;
    document.querySelector('#emailInputModal').value = userData.email;
  });
});

// const editModalForm = document.querySelector('#editModalForm');
// editModalForm.addEventListener('submit', (e) => {
//   e.preventDefault();
// });
