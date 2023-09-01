# Update a web resource in your Dynamics 365 instance
This GitHub Action automates the process of deploying and then publishing a new update to a web resource, which is very typically code.. It's ideal for CI/CD pipelines where Dynamics web resource changes need to be published automatically.

## Features
- Deploys your specified web resource to your Dynamics instance.
- Publishes the change to make it available to users.
- Supports authentication via client credentials - an application user in your Dynamics instance.

## Inputs
- `dynamics-url` - **Required**. The URL of your Dynamics instance. This is not the API URL, this is the URL you can find when you are using the application (ie -> yourorg.crm.dynamics.com not yourorg.api.crm.dynamics.com).
- `client-id` - **Required**. The Client ID of the application created in Microsoft Azure that connects to the application user
- `client-secret` - **Required**. The Client Secret of the application created in Microsoft Azure that connects to the application user
- `tenant-id` - **Required**. The Tenant ID of the application created in Microsoft Azure that connects to the application user
- `web-resource-guid` - **Required**. The GUID of the web resource you want to update. If you don't know how to get that - please visit this website: https://www.guidgenerator.com/online-guid-generator.aspx
- `web-resource-file-path` - **Required** This is the path to the file that has the content you want to update your web resource with. This can be a relative path from the root of your repository or an absolute path. If you are using a relative path, make sure you are using the `actions/checkout@v2` action before this action.

Best practice would be holding the first four values as repository secrets and then using them as secrets instead of plain values. Here is documentation about how to use secrets in GitHub Actions: https://docs.github.com/en/actions/security-guides/encrypted-secrets

## Usage

### Add Action to Workflow

To include this action in your GitHub Workflow, add the following step:

```yaml
    - name: Publish changes to Microsoft Dynamics instance
      uses: dynamics-tools/update-web-resource@v1.0.0
      with:
        dynamics-url: 'https://example.com' # alternatively secrets.DYNAMICS_URL
        application-id: '0000-0000-0000-0000' # alternatively secrets.APPLICATION_ID
        application-secret: '.akdjfoawiefe-~kdja' # alternatively secrets.APPLICATION_SECRET
        tenant-id: '0000-0000-0000-0000' # alternatively secrets.TENANT_ID
        web-resource-guid: '0000-0000-0000-0000'
        web-resource-file-path: 'path/to/file.js'
```

### Example Workflow

```yaml
name: Publish Changes

on:
  push:
    branches:
      - main

jobs:
  publish:
    runs-on: ubuntu-latest
    steps:
    - name: Checkout code
      uses: actions/checkout@v2

    - name: Publish changes to Microsoft Dynamics instance
      uses: dynamics-tools/update-web-resource@v1.0.0
      with:
        dynamics-url: secrets.DYNAMICS_URL
        application-id: secrets.APPLICATION_ID
        application-secret: secrets.APPLICATION_SECRET
        tenant-id: secrets.TENANT_ID
```