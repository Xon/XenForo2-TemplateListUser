# TemplateListUser

Fetch lists of users for templates

## Usage
```
<xf:macro template="sv_list_users" 
          name="info"
          arg-criteria="{{ [] }} "
          />
```

Supported attributes;
- user_id/not_user_id
- secondary_group_ids/not_secondary_group_ids
- no_secondary_group_ids
- Any field on the User/User.Option/User.Profile/User.Privacy
