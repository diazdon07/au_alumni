                <!-- Miantenance -->
                <!-- Users  -->
                <div class="card" id="userForm">
                    <div class="card-header">
                        <i class="fa-solid fa-user-gear"></i> <span class="ms-1 d-sm-inline">Users</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Display name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Mobile</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                foreach( $users as $user ):
                                ?>
                                <tr>
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><?= $user->displayName ?></td>
                                  <td><?= $user->email ?></td>
                                  <td><?= $user->phoneNumber ?></td>
                                  <td>
                                    <button class="btn btn-danger" role="button">Delete</button>
                                    <button class="btn btn-warning" role="button">Disable</button>
                                  </td>
                                </tr>
                                <?php
                                endforeach;
                                ?>
                              </tbody>
                        </table>
                    </div>
                </div>