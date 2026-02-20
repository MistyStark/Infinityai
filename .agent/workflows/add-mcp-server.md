---
description: Add an MCP server configuration to the project
---

# Add MCP Server

This workflow documents how to add an MCP server configuration.

1.  Edit `mcp-servers.json` (or create it if it doesn't exist) in the workspace root.
2.  Add a new entry under `mcpServers`.

Example configuration for `mcp-wordpress-remote`:

```json
{
  "mcpServers": {
    "my-server": {
      "command": "npx",
      "args": ["-y", "@automattic/mcp-wordpress-remote@latest"],
      "env": {
        "WP_API_URL": "https://example.com/wp-json/mcp/v1",
        "WP_API_USERNAME": "username",
        "WP_API_PASSWORD": "password"
      }
    }
  }
}
```
