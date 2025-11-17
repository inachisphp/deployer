# deployer config
Default deployer configuration for inachis. Extract a release of this over the top of your inachis project, and then add an inventory.yaml defining your target hosts suhc as in the example below:

**inventory.yaml**
```yaml
hosts:
  production:
    hostname: your.server.ip
    user: deploy
    stage: production
    deploy_path: /var/www/myapp
    branch: main
    
  staging:
    hostname: staging.example.com
    user: deploy
    stage: staging
    deploy_path: /var/www/my-app-staging
```

If used against production, you will see a folder structure such as:

```
/var/www/myapp
├── current -> releases/17
├── releases
│   ├── 15
│   ├── 16
│   └── 17
└── shared
    ├── .env
    ├── .env.local
    ├── public
    │   └── imgs
    └── var
        ├── cache
        ├── log
        ├── sessions
        └── uploads
```

Your virtual host should be pointed at `/var/www/myapp/current/public`.