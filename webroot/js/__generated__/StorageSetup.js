class StorageSetup extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      storageConfig: {}
    };
    document.addEventListener('mouseup', event => {
      let activeDropdown = document.querySelector('[id^="dropdown"]:not(.d-none)');

      if (activeDropdown != null && !activeDropdown.contains(event.target)) {
        activeDropdown.classList.add('d-none');
      }
    });
  }

  _createVolume(controllerID, drive) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    let volume = Object.assign({}, drive);
    let dropdown = document.getElementById(`add-drive-${drive['id']}-quantity`);
    volume['quantity'] = parseInt(dropdown.value);
    storageConfig[controllerID] = storageConfig?.[controllerID] ?? {};
    storageConfig[controllerID]['volumes'] = storageConfig[controllerID]?.['volumes'] ?? [];
    storageConfig[controllerID]['volumes'].push(volume);

    this._closeCurrentlyOpenDropdown();

    this.setState({
      storageConfig: storageConfig
    });
  }

  _removeVolume(controllerID, volumeIndex) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    storageConfig[controllerID]['volumes'].splice(volumeIndex, 1);

    if (storageConfig[controllerID]['volumes'].length === 0) {
      delete storageConfig[controllerID]['volumes'];
    }

    if (Object.keys(storageConfig[controllerID]).length === 0) {
      delete storageConfig[controllerID];
    }

    this.setState({
      storageConfig: storageConfig
    });
  }

  _createGlobalHotSpare(controllerID, drive) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    let globalHotSpare = Object.assign({}, drive);
    globalHotSpare['quantity'] = 1;
    storageConfig[controllerID] = storageConfig?.[controllerID] ?? {};
    storageConfig[controllerID]['globalHotSpare'] = globalHotSpare;

    this._closeCurrentlyOpenDropdown();

    this.setState({
      storageConfig: storageConfig
    });
  }

  _changeRaidLevel(controllerID, driveID, raidLevel) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    storageConfig[controllerID]['volumes'].find(volume => volume['id'] === driveID)['RAID Level'] = raidLevel;
    this.setState({
      storageConfig: storageConfig
    });
  }

  _updateVolumeDriveQuantity(controllerID, volumeIndex, quantity) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    storageConfig[controllerID]['volumes'][volumeIndex]['quantity'] = quantity;
    this.setState({
      storageConfig: storageConfig
    });
  }

  _removeGlobalHotSpare(controllerID) {
    let storageConfig = Object.assign({}, this.state.storageConfig);
    delete storageConfig[controllerID]['globalHotSpare'];

    if (Object.keys(storageConfig[controllerID]).length === 0) {
      delete storageConfig[controllerID];
    }

    this.setState({
      storageConfig: storageConfig
    });
  }

  _getQuantityOfAssignedDrive(driveID) {
    let assignedDrives = Object.values(this.state.storageConfig).reduce((carry, {
      volumes,
      globalHotSpare
    }) => {
      return carry.concat(volumes ?? [], globalHotSpare ? [globalHotSpare] : []);
    }, []);
    return assignedDrives.filter(assignedDrive => assignedDrive['id'] === driveID).reduce((quantity, assignedDrive) => quantity + assignedDrive['quantity'], 0);
  }

  _getAvailableQuantityOfDrive(driveID) {
    let totalQuantity = Object.values(this.props.currentConfig).flat().find(item => item['id'] === driveID)['quantity'];

    let usedQuantity = this._getQuantityOfAssignedDrive(driveID);

    return totalQuantity - usedQuantity;
  }

  _getAvailablePortsInController(controllerID) {
    let volumes = this.state.storageConfig?.[controllerID]?.['volumes'] ?? [];
    let globalHotSpare = this.state.storageConfig?.[controllerID]?.['globalHotSpare'];
    return volumes.reduce((carry, drive) => carry + drive['quantity'], globalHotSpare?.['quantity'] ?? 0);
  }

  _openDropdown(dropdownID) {
    document.getElementById(dropdownID).classList.remove('d-none');
  }

  _closeCurrentlyOpenDropdown() {
    let activeDropdown = document.querySelector('[id^="dropdown"]:not(.d-none)');
    activeDropdown.classList.add('d-none');
  }

  render() {
    let unassignedDrives = this.props.system['buckets'].filter(bucket => bucket['category'].includes('Drive')).reduce((carry, bucket) => {
      return carry.concat(this.props.currentConfig[bucket['id']].filter(item => {
        if (item['selected_at'] == null) {
          return false;
        }

        return this._getQuantityOfAssignedDrive(item['id']) < item['quantity'];
      }));
    }, []);
    let controllers = this.props.system['buckets'].filter(bucket => bucket['category'].includes('Controller')).reduce((carry, bucket) => {
      return carry.concat(this.props.currentConfig[bucket['id']].filter(item => item['selected_at'] != null));
    }, []);
    return /*#__PURE__*/React.createElement(React.Fragment, null, unassignedDrives.length > 0 && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("h3", {
      className: "fw-bold"
    }, "Unassigned Drives"), /*#__PURE__*/React.createElement("div", {
      className: "row -m-2"
    }, unassignedDrives.map(unassignedDrive => {
      let availableQuantity = unassignedDrive['quantity'] - this._getQuantityOfAssignedDrive(unassignedDrive['id']);

      return /*#__PURE__*/React.createElement("div", {
        className: "col-lg-4 col-md-6 p-2"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex bg-white p-3 shadow-sm h-100"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center bg-white me-3",
        style: {
          width: 50,
          height: 50
        }
      }, /*#__PURE__*/React.createElement("img", {
        className: "mw-100 mh-100",
        src: unassignedDrive['image']
      })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
        className: "fw-bold"
      }, unassignedDrive['name']), /*#__PURE__*/React.createElement("div", {
        className: "d-flex align-items-center"
      }, [...Array(availableQuantity).keys()].map(_ => /*#__PURE__*/React.createElement("div", {
        className: "bg-primary me-1",
        style: {
          width: 10,
          height: 10
        }
      })), /*#__PURE__*/React.createElement("div", {
        className: 'ms-1 ' + (unassignedDrive['quantity'] > 0 ? 'text-success' : 'text-muted')
      }, availableQuantity, " Available")))));
    }))), unassignedDrives.length > 0 && controllers.length > 0 && /*#__PURE__*/React.createElement("hr", {
      className: "my-5"
    }), controllers.length > 0 && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("h3", {
      className: "fw-bold"
    }, "Controllers"), /*#__PURE__*/React.createElement("div", {
      className: "item-group-vertical"
    }, Object.values(controllers).map(controller => {
      let raidLevelsString = controller['specs'].find(spec => spec['name'] === 'RAID Levels')?.['value'] ?? '';
      let raidLevels = raidLevelsString.includes('JBOD') ? ['JBOD'] : [];
      raidLevels = raidLevels.concat(raidLevelsString.split(/[^0-9]+/).filter(raidLevel => raidLevel));
      let totalPorts = parseInt((controller['specs'].find(spec => spec['name'].includes('Ports'))?.['value'] ?? '0').replace('/[^\d.]/g', ''));

      let availablePorts = totalPorts - this._getAvailablePortsInController(controller['id']);

      let dropdownButtons = [];

      if (availablePorts > 0) {
        if (unassignedDrives.length > 0) {
          dropdownButtons.push('Create Volume');
        }

        if (this.state.storageConfig?.[controller['id']]?.['globalHotSpare'] == null) {
          dropdownButtons.push('Global Hot Spare');
        }
      }

      return /*#__PURE__*/React.createElement("div", {
        className: "bg-white p-3 shadow-sm"
      }, /*#__PURE__*/React.createElement("div", {
        className: "item-group align-items-center"
      }, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center bg-white",
        style: {
          width: 50,
          height: 50
        }
      }, /*#__PURE__*/React.createElement("img", {
        className: "mw-100 mh-100",
        src: controller['image']
      })), /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
        className: "fw-bold"
      }, controller['name']), /*#__PURE__*/React.createElement("div", null, raidLevels ? `Supports: ${raidLevels.join(', ')}` : controller['specs'].map(spec => spec['value']).join(' ')), /*#__PURE__*/React.createElement("div", {
        className: "d-flex align-items-center"
      }, [...Array(totalPorts).keys()].map(index => /*#__PURE__*/React.createElement("div", {
        className: 'me-1 ' + (index < availablePorts ? 'bg-primary' : 'bg-4'),
        style: {
          width: 10,
          height: 10
        }
      })), /*#__PURE__*/React.createElement("div", {
        className: 'ms-1 ' + (availablePorts > 0 ? 'text-success' : 'text-muted')
      }, availablePorts, " Port(s) Available"))), dropdownButtons.length > 0 && /*#__PURE__*/React.createElement("div", {
        className: "ms-auto"
      }, /*#__PURE__*/React.createElement("div", {
        className: "item-group align-items-center"
      }, dropdownButtons.map(volumeType => {
        let dasherizedType = volumeType.toLowerCase().replace(' ', '-');
        return /*#__PURE__*/React.createElement("div", {
          className: "dropdown"
        }, /*#__PURE__*/React.createElement("a", {
          className: "btn btn-primary btn-sm",
          href: `#${dasherizedType}`,
          onClick: () => this._openDropdown(`dropdown-${controller['id']}-${dasherizedType}`)
        }, volumeType), /*#__PURE__*/React.createElement("div", {
          id: `dropdown-${controller['id']}-${dasherizedType}`,
          className: "position-absolute zindex-dropdown end-0 bg-white border shadow-sm mt-1 p-3 d-none",
          style: {
            'minWidth': '50rem'
          }
        }, /*#__PURE__*/React.createElement("div", {
          className: "d-flex justify-content-end"
        }, /*#__PURE__*/React.createElement("a", {
          href: "#close-dropdown",
          onClick: () => this._closeCurrentlyOpenDropdown()
        }, /*#__PURE__*/React.createElement("span", {
          className: "bg-black text-white icon-cancel",
          "aria-hidden": "true"
        }))), /*#__PURE__*/React.createElement("div", {
          className: "fw-bold mb-3"
        }, controller['name']), /*#__PURE__*/React.createElement("table", {
          className: "w-100"
        }, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", null, /*#__PURE__*/React.createElement("th", null, "Drive"), /*#__PURE__*/React.createElement("th", null, "Qty"), /*#__PURE__*/React.createElement("th", null, "Action"))), /*#__PURE__*/React.createElement("tbody", null, unassignedDrives.map(unassignedDrive => /*#__PURE__*/React.createElement("tr", null, /*#__PURE__*/React.createElement("td", {
          className: "w-100"
        }, unassignedDrive['name']), /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("select", {
          className: "form-control form-control-sm w-auto me-3",
          id: `add-drive-${unassignedDrive['id']}-quantity`
        }, Array.from({
          length: Math.min(availablePorts, this._getAvailableQuantityOfDrive(unassignedDrive['id']))
        }, (_, i) => i + 1).map(quantity => /*#__PURE__*/React.createElement("option", {
          value: quantity
        }, quantity)))), /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("a", {
          className: "btn btn-primary btn-sm",
          href: `#${dasherizedType}`,
          onClick: () => volumeType === 'Global Hot Spare' ? this._createGlobalHotSpare(controller['id'], unassignedDrive) : this._createVolume(controller['id'], unassignedDrive)
        }, "Add"))))))));
      })))), controller['id'] in this.state.storageConfig && /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement("hr", null), /*#__PURE__*/React.createElement("table", null, /*#__PURE__*/React.createElement("thead", null, /*#__PURE__*/React.createElement("tr", null, /*#__PURE__*/React.createElement("th", {
        colSpan: "3"
      }), /*#__PURE__*/React.createElement("th", {
        className: "fw-bold"
      }, "Quantity"), /*#__PURE__*/React.createElement("th", {
        className: "fw-bold"
      }, "Action"))), /*#__PURE__*/React.createElement("tbody", null, this.state.storageConfig?.[controller['id']]?.['volumes'] != null && this.state.storageConfig[controller['id']]['volumes'].map((assignedDrive, volumeIndex) => /*#__PURE__*/React.createElement("tr", null, /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center bg-white",
        style: {
          width: 40,
          height: 40
        }
      }, /*#__PURE__*/React.createElement("img", {
        className: "mw-100 mh-100",
        src: assignedDrive['image']
      }))), /*#__PURE__*/React.createElement("td", {
        className: "border-right px-3 text-nowrap"
      }, /*#__PURE__*/React.createElement("div", {
        className: "fw-bold"
      }, "Volume #", volumeIndex + 1), /*#__PURE__*/React.createElement("div", null, "Data Volume")), /*#__PURE__*/React.createElement("td", {
        className: "px-3 py-2 w-100"
      }, /*#__PURE__*/React.createElement("div", null, assignedDrive['name']), /*#__PURE__*/React.createElement("div", {
        className: "d-flex align-items-center"
      }, /*#__PURE__*/React.createElement("select", {
        className: "form-control form-control-sm text-small w-auto",
        onChange: e => this._changeRaidLevel(controller['id'], assignedDrive['id'], e.target.value)
      }, /*#__PURE__*/React.createElement("option", {
        value: ""
      }, "None"), raidLevels.map(raidLevel => /*#__PURE__*/React.createElement("option", {
        value: raidLevel
      }, isNaN(raidLevel) ? raidLevel : `RAID ${raidLevel}`))), /*#__PURE__*/React.createElement("span", {
        className: "ms-2"
      }, "Individual disks"))), /*#__PURE__*/React.createElement("td", {
        className: "pe-3"
      }, /*#__PURE__*/React.createElement("select", {
        className: "form-control form-control-sm w-auto",
        value: assignedDrive['quantity'],
        onChange: e => this._updateVolumeDriveQuantity(controller['id'], volumeIndex, parseInt(e.target.value))
      }, Array.from({
        length: assignedDrive['quantity'] + Math.min(this._getAvailableQuantityOfDrive(assignedDrive['id']), availablePorts)
      }, (_, i) => i + 1).map(quantity => /*#__PURE__*/React.createElement("option", {
        value: quantity
      }, quantity)))), /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("a", {
        className: "text-decoration-none",
        href: "#remove-volume",
        onClick: () => this._removeVolume(controller['id'], volumeIndex)
      }, "Remove")))), this.state.storageConfig?.[controller['id']]?.['globalHotSpare'] != null && /*#__PURE__*/React.createElement("tr", null, /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("div", {
        className: "d-flex justify-content-center align-items-center bg-white",
        style: {
          width: 40,
          height: 40
        }
      }, /*#__PURE__*/React.createElement("img", {
        className: "mw-100 mh-100",
        src: controller['image']
      }))), /*#__PURE__*/React.createElement("td", {
        className: "border-right px-3 text-nowrap"
      }, /*#__PURE__*/React.createElement("div", {
        className: "fw-bold"
      }, "Global Hot ", /*#__PURE__*/React.createElement("br", null), " Spare")), /*#__PURE__*/React.createElement("td", {
        className: "px-3 py-2 w-100"
      }, this.state.storageConfig[controller['id']]['globalHotSpare']['name']), /*#__PURE__*/React.createElement("td", {
        className: "pe-3"
      }, /*#__PURE__*/React.createElement("select", {
        value: "1",
        disabled: true
      }, /*#__PURE__*/React.createElement("option", {
        value: "1"
      }, "1"))), /*#__PURE__*/React.createElement("td", null, /*#__PURE__*/React.createElement("a", {
        className: "text-decoration-none",
        href: "#remove-global-hot-spare",
        onClick: () => this._removeGlobalHotSpare(controller['id'])
      }, "Remove")))))));
    }))));
  }

}