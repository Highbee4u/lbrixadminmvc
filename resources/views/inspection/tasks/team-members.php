<!-- Team Members List -->
<?php if (!empty($teamMembers)): ?>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Team Member</th>
                    <th>Comment</th>
                    <th>Assigned Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teamMembers as $member): ?>
                    <tr id="team-member-row-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>">
                                                <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        id="edit-btn-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>"
                                        onclick="editTeamMemberComment(<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm d-none"
                                        id="save-btn-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>"
                                        onclick="saveTeamMemberComment(<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>)">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-none"
                                        id="cancel-btn-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>"
                                        onclick="cancelEditComment(<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>)">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeTeamMember(<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars(trim(($member['firstname'] ?? '') . ' ' . ($member['middlename'] ?? '')), ENT_QUOTES); ?></td>
                        <td>
                            <span id="comment-display-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>"><?php echo htmlspecialchars($member['comment'] ?? 'No comment', ENT_QUOTES); ?></span>
                            <textarea class="form-control form-control-sm d-none"
                                      id="comment-input-<?php echo htmlspecialchars($member['inspectionteamid'] ?? '', ENT_QUOTES); ?>"
                                      rows="2"><?php echo htmlspecialchars($member['comment'] ?? '', ENT_QUOTES); ?></textarea>
                        </td>
                        <td><?php echo !empty($member['entrydate']) ? date('d/m/y', strtotime($member['entrydate'])) : ''; ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-muted">No team members assigned to this inspection task yet.</p>
<?php endif; ?>