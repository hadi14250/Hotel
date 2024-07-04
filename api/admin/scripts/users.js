function get_users(){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      document.getElementById('users-data').innerHTML = this.responseText;
  };

  xhr.send('get_users'); 
}


function toggleStatus(id, val) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if(this.responseText==1){
      alert('success','Status toggled');
      get_users();
    }
    else{
      alert('success','server down')
    }
  };

  xhr.send('toggleStatus=' + id + '&value=' + val);
}


function remove_user(user_id) {


if(confirm("Are u sure,u want to remove this user ?")){
  let data = new FormData();
  data.append('user_id', user_id);
  data.append('remove_user', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);

  xhr.onload = function () {
      if (this.responseText==1) {
          alert('success', 'User removed!');
          get_users();
      } else {
          alert('error', 'User removal failed' );
      }
  };

  xhr.send(data);
}
  

}


function search_user(username){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/users.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
      document.getElementById('users-data').innerHTML = this.responseText;
  };

  xhr.send('search_user&name='+username); 
}



window.onload = function() {
  get_users(); 
};
