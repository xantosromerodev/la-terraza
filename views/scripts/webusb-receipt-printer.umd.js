!(function (e, t) {
  "object" == typeof exports && "undefined" != typeof module
    ? (module.exports = t())
    : "function" == typeof define && define.amd
    ? define(t)
    : ((e =
        "undefined" != typeof globalThis
          ? globalThis
          : e || self).WebUSBReceiptPrinter = t());
})(this, function () {
  "use strict";
  class e {
    constructor(e) {
      this._events = {};
    }
    on(e, t) {
      (this._events[e] = this._events[e] || []), this._events[e].push(t);
    }
    emit(e, ...t) {
      let i = this._events[e];
      i &&
        i.forEach((e) => {
          setTimeout(() => e(...t), 0);
        });
    }
  }
  const t = [
    {
      filters: [{ vendorId: 1155, productId: 22339 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "default",
    },
    {
      filters: [{ vendorId: 1046, productId: 20497 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "zjiang",
    },
    {
      filters: [{ vendorId: 1155, productId: 22592 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "mpt",
    },
    {
      filters: [{ vendorId: 1049 }, { vendorId: 5380 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "bixolon",
    },
    {
      filters: [{ vendorId: 1305 }],
      configuration: 1,
      interface: 0,
      language: (e) => {
        let t = "star-line",
          i = e.productName;
        switch (
          ((i = i.replace(/^Star\s+/i, "")),
          (i = i.replace(
            /^TSP(1|4|6|7|8|10)(13|43)(.*)?$/,
            (e, t, i, n) => "TSP" + t + "00" + (n || "")
          )),
          (i = i.replace(
            /^TSP(55|65)(1|4)(.*)?$/,
            (e, t, i, n) => "TSP" + t + "0" + (n || "")
          )),
          (i = i.replace(
            /^TSP([0-9]+)(II|III|IV|V|VI)?(.*)?$/,
            (e, t, i) => "TSP" + t + (i || "")
          )),
          i)
        ) {
          case "TSP100IV":
          case "mPOP":
          case "mC-Label3":
          case "mC-Print3":
          case "mC-Print2":
            t = "star-prnt";
            break;
          case "TSP100":
          case "TSP100II":
          case "TSP100III":
            t = "star-graphics";
            break;
          case "BSC10":
          case "BSC10BR":
          case "BSC10II":
            t = "esc-pos";
        }
        return t;
      },
      codepageMapping: "star",
    },
    {
      filters: [{ vendorId: 1208 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "epson",
    },
    {
      filters: [{ vendorId: 7568 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "citizen",
    },
    {
      filters: [{ vendorId: 1497 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "hp",
    },
    {
      filters: [{ vendorId: 1221 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "epson",
    },
    {
      filters: [{ vendorId: 4070, productId: 33054 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "epson",
    },
    {
      filters: [{ vendorId: 8137, productId: 8214 }],
      configuration: 1,
      interface: 0,
      language: "esc-pos",
      codepageMapping: "xprinter",
    },
  ];
  class i {}
  return class extends i {
    #e;
    #t = null;
    #i = null;
    #n = { input: null, output: null };
    constructor() {
      super(),
        (this.#e = new e()),
        navigator.usb.addEventListener("disconnect", (e) => {
          this.#t == e.device && this.#e.emit("disconnected");
        });
    }
    async connect() {
      try {
        let e = await navigator.usb.requestDevice({
          filters: t.map((e) => e.filters).reduce((e, t) => e.concat(t)),
        });
        e && (await this.#a(e));
      } catch (e) {
        console.log("Could not connect! " + e);
      }
    }
    async reconnect(e) {
      let t = await navigator.usb.getDevices(),
        i = t.find((t) => t.serialNumber == e.serialNumber);
      i ||
        (i = t.find(
          (t) => t.vendorId == e.vendorId && t.productId == e.productId
        )),
        i && (await this.#a(i));
    }
    async #a(e) {
      (this.#t = e),
        (this.#i = t.find((e) =>
          e.filters.some((e) =>
            e.vendorId && e.productId
              ? e.vendorId == this.#t.vendorId &&
                e.productId == this.#t.productId
              : e.vendorId == this.#t.vendorId
          )
        )),
        await this.#t.open(),
        await this.#t.selectConfiguration(this.#i.configuration),
        await this.#t.claimInterface(this.#i.interface);
      let i = this.#t.configuration.interfaces.find(
        (e) => e.interfaceNumber == this.#i.interface
      );
      (this.#n.output = i.alternate.endpoints.find(
        (e) => "out" == e.direction
      )),
        (this.#n.input = i.alternate.endpoints.find(
          (e) => "in" == e.direction
        )),
        await this.#t.reset(),
        this.#e.emit("connected", {
          type: "usb",
          manufacturerName: this.#t.manufacturerName,
          productName: this.#t.productName,
          serialNumber: this.#t.serialNumber,
          vendorId: this.#t.vendorId,
          productId: this.#t.productId,
          language: await this.#s(this.#i.language),
          codepageMapping: await this.#s(this.#i.codepageMapping),
        });
    }
    async #s(e) {
      return "function" == typeof e ? await e(this.#t) : e;
    }
    async listen() {
      if (this.#n.input) return this.#c(), !0;
    }
    async #c() {
      if (this.#t)
        try {
          const e = await this.#t.transferIn(this.#n.input.endpointNumber, 64);
          e instanceof USBInTransferResult &&
            e.data.byteLength &&
            this.#e.emit("data", e.data),
            this.#c();
        } catch (e) {}
    }
    async disconnect() {
      this.#t &&
        (await this.#t.close(),
        (this.#t = null),
        (this.#i = null),
        this.#e.emit("disconnected"));
    }
    async print(e) {
      if (this.#t && this.#n.output)
        try {
          await this.#t.transferOut(this.#n.output.endpointNumber, e);
        } catch (e) {
          console.log(e);
        }
    }
    addEventListener(e, t) {
      this.#e.on(e, t);
    }
  };
});
//# sourceMappingURL=webusb-receipt-printer.umd.js.map
